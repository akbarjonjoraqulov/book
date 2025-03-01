<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use ApiPlatform\OpenApi\Model\Response;
use App\Controller\GetBooksByCategoryAction;
use App\Controller\GetBooksHardExampleAction;
use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: 'books/by_category',
            controller: GetBooksByCategoryAction::class,
            openapi: new Operation(
                responses: [
                    '200' => new Response(
                        description: 'A list of books retrieved successfully.'
                    ),
                    '400' => new Response(
                        description: 'Invalid category ID provided.'
                    )
                ],
                summary: 'Retrieve books by category',
                parameters: [
                    new Parameter(
                        name: 'categoryId',
                        in: 'query',
                        description: 'ID of the category for which books should be retrieved',
                        required: true,
                        schema: [
                            'type' => 'integer'
                        ]
                    )
                ]
            ),
            name: 'getBooks',
        ),
        new GetCollection(
            uriTemplate: 'books/hard_example',
            controller: GetBooksHardExampleAction::class,
            name: 'booksHardExample',
        ),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
        new Get()
    ],
    normalizationContext: [ 'groups' => ['book:read']],
    denormalizationContext: ['groups' => ['book:write']],
)]
#[Groups(['book:read'])]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['book:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:write'])]
    private ?string $discription = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['book:write'])]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['book:write'])]
    private ?Category $category = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['book:write'])]
    private ?MediaObject $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDiscription(): ?string
    {
        return $this->discription;
    }

    public function setDiscription(string $discription): static
    {
        $this->discription = $discription;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(MediaObject $image): static
    {
        $this->image = $image;

        return $this;
    }
}
