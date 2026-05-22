<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Курсы валют</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0f172a;
            color: white;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .card {
            width: 100%;
            max-width: 700px;
            background: #111827;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,.4);
        }

        .title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 25px;
        }

        .currencies {
            display: grid;
            gap: 15px;
        }

        .currency {
            background: #1e293b;
            border-radius: 14px;
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: .2s;
        }

        .currency:hover {
            transform: translateY(-2px);
            background: #273449;
        }

        .left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .flag {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .code {
            font-size: 18px;
            font-weight: bold;
        }

        .name {
            color: #94a3b8;
            font-size: 14px;
        }

        .rate {
            font-size: 22px;
            font-weight: bold;
            color: #38bdf8;
        }

        .updated {
            margin-top: 25px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        .loading {
            text-align: center;
            padding: 30px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="title">
        Курсы валют к тенге
    </div>

    <div class="subtitle">
        Актуальные данные в реальном времени
    </div>

    <div class="currencies" id="currencies">
        <div class="loading">
            Загрузка курсов...
        </div>
    </div>

    <div class="updated" id="updated"></div>
</div>

<script>
    const currencies = [
        { code: 'USD', name: 'Доллар США', flag: '🇺🇸' },
        { code: 'RUB', name: 'Российский рубль', flag: '🇷🇺' },
        { code: 'BYN', name: 'Белорусский рубль', flag: '🇧🇾' },
        { code: 'UAH', name: 'Украинская гривна', flag: '🇺🇦' },
        { code: 'CNY', name: 'Китайский юань', flag: '🇨🇳' },
        { code: 'EUR', name: 'Евро', flag: '🇪🇺' },
    ];

    async function loadRates() {
        try {
            const response = await fetch('https://fxapi.app/api/KZT.json');

            const data = await response.json();

            const container = document.getElementById('currencies');

            container.innerHTML = '';

            currencies.forEach(currency => {

                const rate = data.rates[currency.code];

                if (!rate) return;

                const finalRate = (1 / rate).toFixed(2);

                container.innerHTML += `
                    <div class="currency">
                        <div class="left">
                            <div class="flag">${currency.flag}</div>

                            <div>
                                <div class="code">${currency.code}</div>
                                <div class="name">${currency.name}</div>
                            </div>
                        </div>

                        <div class="rate">
                            ${finalRate} ₸
                        </div>
                    </div>
                `;
            });

            document.getElementById('updated').innerHTML =
                'Обновлено: ' + new Date(data.timestamp).toLocaleString('ru-RU');

        } catch (e) {
            document.getElementById('currencies').innerHTML = `
                <div class="loading">
                    Ошибка загрузки курсов
                </div>
            `;

            console.error(e);
        }
    }

    loadRates();

    setInterval(loadRates, 300000);
</script>

</body>
</html>
