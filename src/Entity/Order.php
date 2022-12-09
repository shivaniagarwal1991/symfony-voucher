<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]

class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private ?string $total_amount = null;

    #[ORM\Column(nullable: true)]
    private ?int $voucher_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private ?string $paid_amount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalAmount(): ?string
    {
        return $this->total_amount;
    }

    public function setTotalAmount(string $total_amount): self
    {
        $this->total_amount = $total_amount;

        return $this;
    }

    public function getVoucherId(): ?int
    {
        return $this->voucher_id;
    }

    public function setVoucherId(?int $voucher_id): self
    {
        $this->voucher_id = $voucher_id;

        return $this;
    }

    public function getPaidAmount(): ?string
    {
        return $this->paid_amount;
    }

    public function setPaidAmount(string $paid_amount): self
    {
        $this->paid_amount = $paid_amount;

        return $this;
    }

    public function getCreatedAt(): mixed
    {
        return $this->created_at->format('Y-m-d H:m:s');
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
