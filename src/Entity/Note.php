<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'tbl_note')]
#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $tmdb_type = null;

    #[ORM\Column]
    private ?int $tmdb_id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $notation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTmdbType(): ?int
    {
        return $this->tmdb_type;
    }

    public function setTmdbType(?int $tmdb_type): static
    {
        $this->tmdb_type = $tmdb_type;

        return $this;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdb_id;
    }

    public function setTmdbId(int $tmdb_id): static
    {
        $this->tmdb_id = $tmdb_id;

        return $this;
    }

    public function getNotation(): ?int
    {
        return $this->notation;
    }

    public function setNotation(?int $notation): static
    {
        $this->notation = $notation;

        return $this;
    }
}
