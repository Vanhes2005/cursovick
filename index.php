<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница | Фиксация нарушений ПДД</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <!--header-->
    <?php include("inc/header.php"); ?>
    <!--end header-->

    <!-- Основной контент -->
    <main class="main-content">
    <div id="report" class="info-block">
            <div class="info-block-header">
                <h2>Сообщите о нарушении</h2>
            </div>
            <div class="info-block-content">
                <p>Если вы стали свидетелем нарушения правил дорожного движения, ДТП или других инцидентов, связанных с транспортными средствами, пожалуйста, сообщите нам. Ваше сообщение поможет улучшить безопасность на дорогах и может спасти жизни.</p>
                <p>Мы предоставляем простую форму для быстрого сообщения о происшествиях, а также контактную информацию для связи с нашими операторами. Ваша конфиденциальность гарантирована.</p>
                <?php if (isset($_SESSION['id_user'])): ?>
                    <p><a href="../forming_statements/index.php" class="btn-report">Сообщить о нарушении</a></p>
                <?php else: ?>
                    <p><a href="../forming_statements/index.php" class="btn-report">Сообщить о нарушении</a></p>
                <?php endif; ?>
                <?php if (isset($_SESSION['id_user'])): ?>
                    <a href="../statements/index.php" class="button">Перейти к заявлениям</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Новый блок: Как это работает -->
        <div id="how-it-works" class="info-block">
            <div class="info-block-header">
                <h2>Как это работает</h2>
            </div>
            <div class="info-block-content">
                <div class="work-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <h3>Зафиксируйте нарушение</h3>
                        <p>Сделайте фото нарушения ПДД</p>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <h3>Заполните форму</h3>
                        <p>Укажите детали нарушения и загрузите материалы через нашу форму.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <h3>Отправьте форму</h3>
                        <p>После проверки ваша форма будет направлена в соответствующие органы.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Новый блок: Частые нарушения -->
        <div id="common-violations" class="info-block">
            <div class="info-block-header">
                <h2>Частые нарушения</h2>
            </div>
            <div class="info-block-content">
                <ul class="violations-list">
                    <li><span class="violation-icon">🚗</span> Превышение скорости</li>
                    <li><span class="violation-icon">🅿️</span> Парковка в неположенном месте</li>
                    <li><span class="violation-icon">🚦</span> Проезд на красный свет</li>
                    <li><span class="violation-icon">🚸</span> Непропуск пешеходов</li>
                    <li><span class="violation-icon">📱</span> Использование телефона за рулем</li>
                </ul>
            </div>
        </div>

        <!-- Новый блок: Статистика -->
        <div id="statistics" class="info-block">
            <div class="info-block-header">
                <h2>Наша статистика</h2>
            </div>
            <div class="info-block-content">
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number">1,250+</div>
                        <div class="stat-desc">сообщений о нарушениях</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">85%</div>
                        <div class="stat-desc">рассмотренных заявлений</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">30+</div>
                        <div class="stat-desc">городов охвата</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Новый блок: Контакты -->
        <div id="contacts" class="info-block">
            <div class="info-block-header">
                <h2>Контакты</h2>
            </div>
            <div class="info-block-content">
                <div class="contacts">
                    <p><strong>Электронная почта:</strong> <a href="https://mail.google.com/mail/u/0/#inbox?compose=CllgCJqXxVnXdsHrKPrGtxzsBvTmjJndpxRtWVdVQBXlkWwQXczZgfwqlRfBRzXgRjHZfFQZlzL">ivanbarbotkin5@gmail.com</a></p>
                    <p><strong>Телефон горячей линии:</strong> <a href="tel:+78001234567">8 (800) 123-45-67</a></p>
                    <p><strong>Время работы:</strong> Пн-Пт с 9:00 до 18:00</p>
                    <div class="social-links">
                        <a href="#" class="social-icon">VK</a>
                        <a href="#" class="social-icon">TG</a>
                        <a href="#" class="social-icon">YT</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--footer-->
    <?php include("inc/footer.php"); ?>
    <!--end footer-->
</body>
</html>