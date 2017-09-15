<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an admin user based on user input';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('Please enter the name of the admin user');

        if (!$this->checkName($name)) {
            $this->error('The name must be alphabetical only');
            exit();
        }

        $email = $this->ask('Please enter the email of the admin user');

        if (!$this->checkEmail($email)) {
            $this->error('The email must be valid');
            exit();
        }

        $password = $this->secret('Please enter the admin password [of at least 8 characters, containing one upper and lower case letter and a number');

        $confirmedPassword = $this->secret('Please confirm the admin password');

        if ($this->passwordEqualityCheck($password, $confirmedPassword) !== 0) {
            $this->error('The password must match');
            exit();
        }
        if (!$this->checkPassword($password)) {
            $this->error('The password must be valid');
            exit();
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'is_admin' => 1
        ]);

        $this->info('Admin user created successfully');
    }

    /**
     * Confirm if a given name is alphabetical only
     *
     * @param $name
     * @return bool
     */
    private function checkName($name)
    {
        return (bool)preg_match('/^[A-z]+$/', $name);
    }

    /**
     * Confirm if a string is matching of the email variant stated in
     * RFC 5322 Official Standard
     * compliments of (http://emailregex.com/)
     *
     * @param $email
     * @return bool
     */
    private function checkEmail($email)
    {
        return (bool)preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',
            $email);
    }

    /**
     * Confirm if a password is
     * of at least 8 characters in length
     * contains one lowercase letter
     * contains one uppercase letter
     * and at least one number
     *
     * @param $password
     * @return bool
     */
    private function checkPassword($password)
    {
        return (bool)preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $password);
    }

    /**
     * Confirm if password string match
     *
     * @param $password
     * @param $confirmedPassword
     * @return int
     */
    private function passwordEqualityCheck($password, $confirmedPassword)
    {
        return strcmp($password, $confirmedPassword);
    }
}
