<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormReceived;
use App\Mail\ContactFormSubmitted;
use App\Validators\ContactFormValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;

class ContactFormController extends Controller
{
    /** @var ContactFormValidator */
    protected $validator;

    /**
     * ContactFormController constructor.
     * @param ContactFormValidator $validator
     */
    public function __construct(ContactFormValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Show contact form page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('web.contact');
    }

    /**
     * Make a contact request.
     *
     * @param Request $request
     * @return array
     */
    public function contact(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'formMessage' => $request->formMessage,
        ];

        if (!$this->validator->with($data)->passes()) {

            return redirect()->route('contact')->withErrors($this->validator->errors())->withInput();
        }

        try {
            // Send to the company mail the new contact request.
            Mail::to(config('mail.contactform.notificationaddress'))
                ->send(new ContactFormReceived($data['name'], $data['email'], $data['formMessage']));

            // Confirm to the user that we have received the contact request.
            Mail::to($data['email'])
                ->send(new ContactFormSubmitted($data['name'], $data['formMessage']));

            return redirect()->route('contact')->withSuccess('Tu mensaje ha sido enviado.');
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('error', 'Ha habido un error al enviar tu mensaje. Puedes contactar con nosotros por Twitter o Facebook en @GeekyTheory.');

            return redirect()->route('contact')->withErrors($errors)->withInput();
        }
    }
}
