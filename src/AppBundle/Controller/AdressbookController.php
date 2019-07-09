<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class AdressbookController extends Controller
{

    /**
     * @Route("/", name="Address book")
     */
    public function contactlistAction()
    {
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository('AppBundle:Contact')->findAll();
        $count = count($contacts);

        return $this->render('Contact/ContactList.html.twig', array(
            'contacts' => $contacts,
            'count' => $count

        ));
    }

    /**
     * @Route("/newcontact", name="newcontact")
     */
    public function newcontactAction(Request $request)
    {
        $contact = new Contact();
        $em=$this->getDoctrine()->getManager();
        $form = $this->createForm(ContactType::class,$contact );
        $form->handleRequest($request);
        if($form->isSubmitted() ) {
            $em->persist($contact);
            $em->flush();
            return $this->redirect($this->generateUrl('Address book',array('msg'=>"add successful")));
        }
        return $this->render('Contact/CreateContact.html.twig',array(
            'form'=>$form->createView(),
        ));
    }

    /**
     * @Route("/detail_contact/{id}", name="detail_contact")
     */
    public function contactdetailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('AppBundle:Contact')->findOneBy(array('id' => $id));

        return $this->render('Contact/ContactDetails.html.twig', array(
            'contact' => $contact,

        ));
    }

    /**
     * @Route("/edit_contact/{id}",name="edit_contact")
     */
    public function editClientAction(Request $request, $id)
    {

            $em = $this->getDoctrine()->getManager();

            $contact = $em->getRepository("AppBundle:Contact")->findOneBy(array('id' => $id));
            $form = $this->createForm(ContactType::class, $contact);


            $form->handleRequest($request);

            if ($form->isSubmitted()) {

                $em->persist($contact);
                $em->flush();

                //
                return $this->redirect($this->generateUrl('Address book'));

            }


            return $this->render('Contact/EditContact.html.twig',
                array(

                    "form" => $form->createView()
                ));
        }



    /**
     * @Route("/delete_contact/{id}",name="delete_contact")
     */
    public function delete_userAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $contact = $em->getRepository('AppBundle:Contact')->findOneBy(array('id' => $id ));
        $em->remove($contact);
        $em->flush();
        return $this->redirect($this->generateUrl('Address book',array('msg'=>"Delete successful")));
    }



}