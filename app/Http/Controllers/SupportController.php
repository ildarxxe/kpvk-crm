<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Support;
use App\Models\Task;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class SupportController extends Controller
{
    public function viewSupport(): Factory|View
    {
        return view('support');
    }

    public function viewRespond($token): Factory|View {
        $support = Support::query()->where('token', $token)->first();
        return view("respond")->with(['support' => $support]);
    }

    public function support(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|max:20480',
        ]);

        $token = Str::uuid();

        $support = Support::query()->create([
            "user_id" => auth()->user()->id,
            "message" => $data["message"],
            "topic" => $data["subject"],
            "token" => $token,
        ]);

        if (isset($data['attachments']) && is_array($data['attachments'])) {
            $files = $data['attachments'];
            $uploadFolder = "supports/{$support->id}";

            if (count($files) > 1) {
                $zipName = 'files_' . time() . '.zip';
                $zipRelativePath = "$uploadFolder/$zipName";

                Storage::disk('public')->makeDirectory($uploadFolder);
                $zipFullPath = Storage::disk('public')->path($zipRelativePath);

                $zip = new ZipArchive;
                if ($zip->open($zipFullPath, ZipArchive::CREATE) === TRUE) {
                    foreach ($files as $file) {
                        $zip->addFile($file->getRealPath(), $file->getClientOriginalName());
                    }
                    $zip->close();
                }

                $support->files()->create([
                    'file_path' => $zipRelativePath,
                    'file_name' => "обращение",
                ]);
            } elseif (count($files) === 1) {
                $file = $files[0];
                $path = $file->store($uploadFolder, 'public');

                $support->files()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        $mailData = [
            "username" => auth()->user()->name,
            "subject" => $data["subject"],
            "message" => $data["message"],
            "attachments" => $data["attachments"] ?? null,
            "token" => $token,
        ];

        Mail::to('ildarmyname@gmail.com')->send(new ContactMail($mailData));

        return redirect()->back()->with("success", "Обращение успешно отправлено!");
    }
}
