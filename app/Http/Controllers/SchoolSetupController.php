<?php

namespace Scalex\Zero\Http\Controllers;

use Illuminate\Http\Request;
use Scalex\Zero\Models\School;
use Znck\Attach\Builder;
use Ramsey\Uuid\Uuid;

class SchoolSetupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function setup(Request $request)
    {
        $user = $request->user();
        $school = $user->school;

        $hasLogo = !is_null($school->logo);

        if (!$school->verified) {
            $instituteTypes = $this->getInstituteTypes();

            return view('setup.school', compact('user', 'school', 'instituteTypes'));
        }

        return redirect()->intended();
    }

    public function handle(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'university' => 'required|max:255',
            'logo' => 'required|image|max:10240',
            'institute_type' => 'required|in:'.implode(',', array_keys($this->getInstituteTypes())),
        ]);


        $school = $request->user()->school;
        $schoolId = $school->getKey();
        $slug = Uuid::uuid4();
        $path = "schools/${schoolId}/logo";

        $photo = Builder::make($request, 'logo')
                        ->resize(300, null, 300)
                        ->upload(compact('slug', 'path'))
                        ->getAttachment();

        $school->logo()->associate($photo);

        $school->verified = true;

        $school->update($request->only(['name', 'email', 'university', 'institute_type']));

        return redirect('/');
    }

    protected function getInstituteTypes()
    {
        return [
            'central_university' => 'Central University',
            'private_aided' => 'Aided (Private)',
            'private_deemed' => 'Deemed University (Private)',
            'private_unaided' => 'Unaided (Private)',
            'private_university' => 'University Managed (Private)',
            'public' => 'Government',
            'public_aided' => 'Aided (Government)',
            'public_deemed' => 'Deemed University (Government)',
            'public_university' => 'University Managed (Government)',
        ];
    }
}
