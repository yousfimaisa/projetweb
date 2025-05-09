<?php
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

    public function getId(): ?int { return $this->id; }
    public function getTypec(): ?string { return $this->typec; }
    public function getCdnumber(): ?string { return $this->cdnumber; }
    public function getDrcode(): ?string { return $this->drcode; }
    public function getBkcode(): ?string { return $this->bkcode; }
    public function getSecuritycode(): ?string { return $this->securitycode; }
    public function getDatee(): ?DateTime { return $this->datee; }
    public function getUserId(): ?int { return $this->user_id; }

    // Setters si nécessaire
}
?>
