<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class TrackRequestDTO
{
    public function __construct(
        #[Assert\NotBlank(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255)]
        public ?string $title = null,
        
        #[Assert\NotBlank(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255)]
        public ?string $artist = null,
        
        #[Assert\NotBlank(groups: ['create'])]
        #[Assert\Positive]
        #[Assert\LessThan(86400)]
        public ?int $duration = null,
        
        #[Assert\Regex(
            pattern: '/^[A-Z]{2}-[A-Z0-9]{3}-\d{2}-\d{5}$/',
            message: 'Invalid ISRC format'
        )]
        public ?string $isrc = null
    ) {}

    public static function fromRequest(Request $request): self
    {
        $data = $request->toArray();

        return new self(
            title: $data['title'] ?? null,
            artist: $data['artist'] ?? null,
            duration: isset($data['duration']) ? (int) $data['duration'] : null,
            isrc: $data['isrc'] ?? null
        );
    }
}