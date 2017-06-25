<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ItemPost;
use AppBundle\Entity\ItemPostPhoto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Itempost controller.
 *
 * @Route("itempost")
 */
class ItemPostController extends Controller
{
    /**
     * Lists all itemPost entities.
     *
     * @Route("/", name="itempost_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $request->get("category");

        $itemPosts = $em->getRepository('AppBundle:ItemPost')->findAllAndSortByDate();

        $bookmarkArray = [];

        if ($this->isGranted('ROLE_USER')) {
            $bookmarks = $em->getRepository('AppBundle:ItemBookmark')->findAllBookmarksByUser($this->getUser());

            foreach($bookmarks as $bookmark){
                $bookmarkArray[] = $bookmark->getItemPost()->getName();
            }
        }

        return $this->render('itempost/index.html.twig', array(
            'itemPosts' => $itemPosts,
            'category'=>$category,
            'bookmarks' => $bookmarkArray
        ));
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     *
     * @Route("/new", name="itempost_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $form = $this->createForm('AppBundle\Form\ItemPostType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $itemPost = $form->getData();
            $itemPost->setPostDate(new \DateTime());
            $itemPost->setUser($this->getUser());

            //gets files form the form
            $files = $itemPost->getPhotoList();

            if ($files != null) {
                foreach($files as $file) {
                    // Generate a unique name for the file before saving it
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    // Move the file to the correct folder
                    $file->move(
                        $this->getParameter('upload_destination'),
                        $fileName
                    );

                    //stores path to file into database
                    $itemPost->addPhoto('/images/ItemPostPhotos/' . $fileName);
                }
            }

            $em->persist($itemPost);
            $em->flush();

            return $this->redirectToRoute('itempost_index');
        }

        return $this->render('itempost/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a itemPost entity.
     *
     * @Route("/{id}", name="itempost_show")
     * @Method("GET")
     */
    public function showAction(ItemPost $itemPost)
    {
        return $this->render('itempost/show.html.twig', array(
            'itemPost' => $itemPost,
        ));
    }

    /**
     * Displays a form to edit an existing itemPost entity.
     *
     * @Route("/{id}/edit", name="itempost_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ItemPost $itemPost)
    {

        $this->denyAccessUnlessGranted('edit', $itemPost);

        $editForm = $this->createForm('AppBundle\Form\ItemPostType', $itemPost);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $files = $itemPost->getPhotoList();

            if ($files != null) {
                foreach($files as $file) {
                    // Generate a unique name for the file before saving it
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    // Move the file to the correct folder
                    $file->move(
                        $this->getParameter('upload_destination'),
                        $fileName
                    );

                    //stores path to file into database
                    $itemPost->addPhoto('/images/ItemPostPhotos/' . $fileName);
                }
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('itempost_index', array('id' => $itemPost->getId()));
        }

        //refreshes itemPost entity from database to prevent from displaying stale images
        $this->getDoctrine()->getManager()->refresh($itemPost);

        return $this->render('itempost/edit.html.twig', array(
            'itemPost' => $itemPost,
            'edit_form' => $editForm->createView()
        ));
    }


    /**
     * @Route("/{id}/delete", name="itempost_delete")
     */
    public function deleteAction(ItemPost $itemPost){

        $this->denyAccessUnlessGranted('delete', $itemPost);

        $em = $this->getDoctrine()->getManager();
        $em->remove($itemPost);
        $em->flush();

        return $this->redirectToRoute('itempost_index');
    }

    /**
     * Removes file from file system
     * Deletes photo entity
     *
     * @Route("/{id}/deletePhoto", name="photo_delete")
     */
    public function photoDeleteAction(ItemPostPhoto $itemPostPhoto, Request $request) {

        $this->denyAccessUnlessGranted('edit', $itemPostPhoto->getItemPost());

        //get the photo name
        $photoName = substr_replace($itemPostPhoto->getPath(), '', 0, 23);

        //builds the absolute path and removes the photo from the file system
        unlink($this->getParameter('upload_destination') . $photoName);

        //deletes photo entity and removes photo path from the database
        $em = $this->getDoctrine()->getManager();
        $em->remove($itemPostPhoto);
        $em->flush();

        //refreshes the page
        return $this->redirectToRoute('itempost_edit', array(
            'id' => $itemPostPhoto->getItemPost()->getId()
        ));

    }

}
