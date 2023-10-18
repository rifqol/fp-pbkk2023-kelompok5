<?php
namespace App\Http\Modules\ECommerce\Domain\Models;

class User
{
    // Schema::create('users', function (Blueprint $table) {
    //     $table->id();
    //     $table->string('name');
    //     $table->string('username');
    //     $table->string('email')->unique();
    //     $table->string('phone');
    //     $table->timestamp('email_verified_at')->nullable();
    //     $table->string('photo_url')->nullable();
    //     $table->string('password');
    //     $table->string('bank_actnumber')->nullable();
    //     $table->boolean('is_admin')->default(false);
    //     $table->rememberToken();
    //     $table->timestamps();
    // });

    public function __construct(
        private ?int $id,
        private string $name,
        private string $username,
        private string $email,
        private string $phone,
        private ?string $email_verified_at,
        private ?string $photo_url,
        private string $password,
        private ?string $bank_actnumber,
        private bool $is_admin,
    ) {}

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getVerifiedAt()
    {
        return $this->email_verified_at;
    }

    public function getPhoto()
    {
        return $this->photo_url;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getBankActNumber()
    {
        return $this->bank_actnumber;
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'email_verified_at' => $this->email_verified_at,
            'photo_url' => $this->photo_url,
            'password' => $this->password,
            'bank_actnumber' => $this->bank_actnumber,
            'is_admin' => $this->is_admin,
        ]
    }
}
