<?php 

namespace NextG\RwAdminApp\Entity;

class User {

    private string $idUser;
    private string $idAuth;
    private string $status;
    private string $userName;
    private string $email;
    private string $noTelp;
    private string $name;
    private string $profileImage;

    
    
    public function __construct($idUser, $idAuth, $status, $userName, $email, $noTelp, $name, $profileImage) {

        $this->idUser = $idUser;
        $this->idAuth = $idAuth;
        $this->status = $status;
        $this->userName = $userName;
        $this->email = $email;
        $this->noTelp = $noTelp;
        $this->name = $name;
        $this->profileImage = $profileImage;
    }

    



    /**
     * Get the value of idUser
     */
    public function getIdUser(): string
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     */
    public function setIdUser(string $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of idAuth
     */
    public function getIdAuth(): string
    {
        return $this->idAuth;
    }

    /**
     * Set the value of idAuth
     */
    public function setIdAuth(string $idAuth): self
    {
        $this->idAuth = $idAuth;

        return $this;
    }

    /**
     * Get the value of userName
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * Set the value of userName
     */
    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of noTelp
     */
    public function getNoTelp(): string
    {
        return $this->noTelp;
    }

    /**
     * Set the value of noTelp
     */
    public function setNoTelp(string $noTelp): self
    {
        $this->noTelp = $noTelp;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of profileImage
     */
    public function getProfileImage(): string
    {
        return $this->profileImage;
    }

    /**
     * Set the value of profileImage
     */
    public function setProfileImage(string $profileImage): self
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}