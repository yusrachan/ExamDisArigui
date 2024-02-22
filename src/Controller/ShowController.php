<?php

namespace App\Controller;

use App\Entity\Showw;
use App\Entity\Reviews;
use App\Form\ReviewsType;
use App\Entity\Reservation;
use App\Repository\ShowwRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class ShowController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'show_index')]
    public function index(ShowwRepository $showwRepository): Response
    {
        return $this->render('show/index.html.twig', [
            'shows' => $showwRepository->findAll(),
        ]);
    }

    #[Route('/show/{id}/comments', name: 'show_comments')]
    public function showComments($id, EntityManagerInterface $entityManager): Response
    {
        $reviewRepository = $entityManager->getRepository(Reviews::class);
        $comments = $reviewRepository->findByShowWithUser($id);

        return $this->render('show/comments.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/show/{id}', name: 'show_view')]
    public function viewShow($id, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $user = $this->getUser();
        $show = $entityManager->getRepository(Showw::class)->find($id);
        if (!$show) {
            throw $this->createNotFoundException('Spectacle non trouvé.');
        }

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        if (!$this->hasPastReservation($show, $user)) {
            throw new AccessDeniedException('Vous devez avoir assisté à ce spectacle pour laisser un commentaire.');
        }

        $review = new Reviews();
        $form = $this->createForm(ReviewsType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($review);
            if (count($errors) > 0) {
                return $this->render('review/new.html.twig', [
                    'form' => $form->createView(),
                    'errors' => $errors,
                ]);
            } else {
                $entityManager->persist($review);
                $entityManager->flush();
            }
        }
        return $this->render('show/view.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    private function hasPastReservation(Showw $showw, UserInterface $user, EntityManagerInterface $entityManager): bool
    {
        $qb = $entityManager->createQueryBuilder();
    
        $query = $qb->select('r')
            ->from(Reservation::class, 'r')
            ->where('r.showw = :showw')
            ->andWhere('r.user = :user')
            ->andWhere('r.date < :now')
            ->setParameters([
                'showw' => $showw,
                'user' => $user,
                'now' => new \DateTime(),
            ])
            ->setMaxResults(1)
            ->getQuery();
    
        $result = $query->getResult();
    
        return !empty($result);
    }

    #[Route('/show/{slug}/comments', name: 'show_comments_by_slug')]
    public function showCommentsBySlug(string $slug, EntityManagerInterface $entityManager): Response
    {
        $show = $entityManager->getRepository(Showw::class)->findOneBy(['slug' => $slug]);
        
        if (!$show) {
            throw $this->createNotFoundException('Le spectacle demandé n\'existe pas.');
        }
        
        $comments = $entityManager->getRepository(Reviews::class)->findBy(['showw' => $show, 'validated' => true], ['id' => 'DESC']);
        
        return $this->render('show/comments_by_slug.html.twig', [
            'show' => $show,
            'comments' => $comments,
        ]);
    }
}
