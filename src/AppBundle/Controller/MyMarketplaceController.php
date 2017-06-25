<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 3/10/17
 * Time: 10:42 PM
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyMarketplaceController extends Controller
{
    /**
     * @Route("/myMarketplace", name="myMarketplace")
     */
    public function myMarketplaceAction(){
        $em = $this->getDoctrine()->getManager();

        $itemPosts = $em->getRepository('AppBundle:ItemPost')->findAllItemsByUser($this->getUser());

        return $this->render('myMarketplace/myItemsForSale.html.twig', [
            'itemPosts' => $itemPosts
        ]);
    }

    /**
     * @Route("/myBookmarks", name="myBookmarks")
     */
    public function myBookmarksAction(){
        $em = $this->getDoctrine()->getManager();

        $myBookmarks = $em->getRepository('AppBundle:ItemBookmark')->findAllBookmarksByUser($this->getUser());

        return $this->render('myMarketplace/myBookmarkedItems.html.twig', [
            'myBookmarks' => $myBookmarks
        ]);
    }
}