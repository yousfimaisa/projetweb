<?

class Pay {
    private ?int $id;
    private ?string $typec;
    private ?string $cdnumber;
    private ?string $drcode;
    private ?string $bkcode;
    private ?string $securitycode;
    private ?DateTime $datee;
    private ?int $user_id;

    public function __construct(
        ?int $id,
        ?string $typec,
        ?string $cdnumber,
        ?string $drcode,
        ?string $bkcode,
        ?string $securitycode,
        ?DateTime $datee,
        ?int $user_id
    ) {
        $this->id = $id;
        $this->typec = $typec;
        $this->cdnumber = $cdnumber;
        $this->drcode = $drcode;
        $this->bkcode = $bkcode;
        $this->securitycode = $securitycode;
        $this->datee = $datee;
        $this->user_id = $user_id;
    }

    public function getUserId(): ?int {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void {
        $this->user_id = $user_id;
    }

    // ... Tes autres getters/setters
}


?>