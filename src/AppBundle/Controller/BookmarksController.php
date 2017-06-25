<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 5/19/17
 * Time: 2:13 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\ItemBookmark;
use AppBundle\Entity\ItemPost;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookmarksController extends Controller
{
    /**
     * @Route("/{id}/bookmarkItem", name="addBookmark")
     */
    public function addBookmarkAction(ItemPost $itemPost){

        $this->addBookmark($itemPost);

        $this->addFlash('success', "Congrats! You just bookmarked ".$itemPost->getName());

        return $this->redirectToRoute('itempost_index');
    }

    /**
     * @Route("/bookmarkItem", name="addBookmarkAjax")
     */
    public function addBookmarkAjaxAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $itemPostId = $request->request->get('itemPostId');
        $itemPost = $em->getRepository('AppBundle:ItemPost')->find($itemPostId);

        $this->addBookmark($itemPost);

        $response = array("code" => 100, "success" => true);

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/removeBookmark", name="removeBookmark")
     */
    public function deleteBookmarkAction(ItemBookmark $itemBookmark){
        $em = $this->getDoctrine()->getManager();

        $em->remove($itemBookmark);
        $em->flush();

        return $this->redirectToRoute('myBookmarks');
    }

    private function addBookmark(ItemPost $itemPost){

        $em = $this->getDoctrine()->getManager();

        $bookmark = new ItemBookmark();

        $bookmark->setUser($this->getUser());
        $bookmark->setItemPost($itemPost);

        $em->persist($bookmark);
        $em->flush();
    }
}