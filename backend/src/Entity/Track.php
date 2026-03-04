<?php

namespace App\Entity;

use App\Repository\TrackRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
#[ORM\Table(name: 'tracks')]
class Track
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Title cannot be blank')]
    #[Assert\Length(min: 1, max: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Artist cannot be blank')]
    #[Assert\Length(min: 1, max: 255)]
    private ?string $artist = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Duration cannot be blank')]
    #[Assert\Positive(message: 'Duration must be a positive number')]
    #[Assert\LessThan(value: 86400, message: 'Duration cannot exceed 24 hours')]
    private ?int $duration = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Assert\Regex(
        pattern: '/^[A-Z]{2}-[A-Z0-9]{3}-\d{2}-\d{5}$/',
        message: 'ISRC must match format: XX-XXX-XX-XXXXX (e.g., US-ABC-23-00123)'
    )]
    private ?string $isrc = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    
    public function getArtist(): ?string { return $this->artist; }
    public function setArtist(string $artist): self { $this->artist = $artist; return $this; }
    
    public function getDuration(): ?int { return $this->duration; }
    public function setDuration(int $duration): self { $this->duration = $duration; return $this; }
    
    public function getIsrc(): ?string { return $this->isrc; }
    public function setIsrc(?string $isrc): self { $this->isrc = $isrc; return $this; }
    
    public function getCreatedAt(): DateTimeImmutable { return $this->createdAt; }
    
    public function getUpdatedAt(): DateTimeImmutable { return $this->updatedAt; }
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }
}