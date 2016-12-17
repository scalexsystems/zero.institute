<?php

namespace Scalex\Zero\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Scalex\Zero\User;
use Validator;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\School;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $institute = $request->input('institute', $request->old('institute'));
        $token = $request->input('token', $request->old('token'));

        if ($institute and $token) {
            $school = repository(School::class)->find($institute);

            $isTokenValid = !is_null($this->validateToken($school, $token));

            return view('auth.register', compact('school', 'institute', 'token', 'isTokenValid'));
        }

        return view('auth.lost');
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $token = $request->input('token');
        $school = repository(School::class)->find($request->input('institute'));

        if (!($user_type = $this->validateToken($school, $token))) {
            return redirect()->back();
        }

        if (!$this->validateEmail($school, $request->input('email'))) {
            return redirect()->back()->with('message', 'Your school does not allow creating accounts with this email address.');
        }

        event(new Registered($user = $this->create($request->all(), $school)));

        $this->guard()->login($user);

        $person = app(morph_model($user_type));
        $person->first_name = $request->input('name');
        $person->school_id = $school->getKey();

        $user->person()->save($person);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => 'required',
            'institute' => 'required|exists:schools,id',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data, School $school): User {
        return repository(User::class)
            ->create([
                'name' => $data['name'],
                'school_id' => $data['institute'],
                'email' => $data['email'],
                'password' => $data['password'],
                'verification_token' => null,
            ]);

    }

    public function validateToken(School $school, string $userToken) {
        $tokens = (array)$school->tokens;

        foreach($tokens as $key => $token) {
            if (Str::is($token, $userToken)) {
                return $key;
            }
        }
    }

    public function validateEmail(School $school, string $email): bool {
        $domains = (array)$school->email_domains;

        if (!count($domains)) return true;

        return Str::endsWith($email, $domains);
    }
}
