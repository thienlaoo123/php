<?php
namespace MyProject\Classes;

/**
 * Класс пользователя.
 *
 * Содержит основные данные о пользователе (имя, логин, пароль)
 * и методы для получения информации и вывода её на экран.
 */
class User
{
    /**
     * Имя пользователя.
     *
     * @var string
     */
    public string $name;

    /**
     * Логин пользователя.
     *
     * @var string
     */
    public string $login;

    /**
     * Пароль пользователя.
     *
     * @var string
     */
    private string $password;

    /**
     * Конструктор пользователя.
     *
     * @param string $name     Имя пользователя.
     * @param string $login    Логин пользователя.
     * @param string $password Пароль пользователя.
     */
    public function __construct(string $name, string $login, string $password)
    {
        $this->name     = $name;
        $this->login    = $login;
        $this->password = $password;
    }

    /**
     * Возвращает имя пользователя.
     *
     * @return string Имя пользователя.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Возвращает логин пользователя.
     *
     * @return string Логин пользователя.
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Возвращает пароль пользователя.
     *
     * @return string Пароль пользователя.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Выводит информацию о пользователе:
     * имя, логин и пароль.
     *
     * @return void
     */
    public function showInfo(): void
    {
        echo 'Имя: '    . $this->name     . '<br />';
        echo 'Логин: '  . $this->login    . '<br />';
        echo 'Пароль: ' . $this->password . '<br />';
        echo '<hr>';
    }

    /**
     * Деструктор пользователя.
     *
     * Выводит сообщение об удалении пользователя.
     */
    public function __destruct()
    {
        echo "Пользователь {$this->getLogin()} удалён<br>";
    }
}
