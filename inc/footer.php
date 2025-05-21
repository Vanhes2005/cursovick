<footer>
    <div class="footer-nav">
        <p><a href="../index.php">Нарушения.ПДД</a></p>
        <p><a href="../index.php#report">Сообщить о нарушении</a></p>
        <p><a href="../index.php#how-it-works">Как это работает</a></p>
        <p><a href="../index.php#common-violations">Частые нарушения</a></p>
        <p><a href="../index.php#statistics">Статистика</a></p>
        <p><a href="../index.php#contacts">Контакты</a></p>
        
        <?php if (isset($_SESSION['id_user'])): ?>
        <p><a href="../forming_statements/index.php">Форма отправки</a></p>
        <p><a href="../statements/index.php">Мои заявления</a></p>
        <?php else: ?>
            <p><a href="../forming_statements/index.php">Форма отправки</a></p>
        <?php endif; ?>
        
        <p><a href="https://mail.google.com/mail/u/0/#inbox?compose=CllgCJqXxVnXdsHrKPrGtxzsBvTmjJndpxRtWVdVQBXlkWwQXczZgfwqlRfBRzXgRjHZfFQZlzL">ivanbarbotkin5@gmail.com</a></p>
    </div>
</footer>