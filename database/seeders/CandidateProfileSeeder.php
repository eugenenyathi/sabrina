<?php

namespace Database\Seeders;

use App\Constants\CandidateProfileConstants;
use App\Constants\SrcPostConstants;
use App\Constants\StudentConstants;
use App\Http\Services\CandidateService;
use App\Models\Candidate;
use App\Models\CandidateProfile;
use App\Traits\FakeCredentials;
use App\Traits\Utils;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    use Utils;
    use FakeCredentials;

    private $maleImgCount = 1;
    private $femaleImgCount = 1;

    public function run(): void
    {
        $profiles = CandidateProfileConstants::PROFILES;
        $candidates = Candidate::all();

        foreach ($profiles as $profile) {
            $profileSrcPostId = $profile['src_post_id'];
            $profileData = $profile['data'];
            $whys = $profileData['whys'];
            $catchPhrases = $profileData['catch_phrases'];

            $candidates = Candidate::where('src_post_id', $profileSrcPostId)->get();

            foreach ($candidates as $key => $candidate) {
                $bio = $whys[$key];
                $catchPhrase = $catchPhrases[$key];
                $contact = $this->generatePhoneNumber();
                $profile_url = 'SRC\\' . $this->imageProvider($candidate->student_id, $profileSrcPostId);

                $candidateHasProfile = CandidateProfile::where('student_id', $candidate->student_id)->exists();

                if (!$candidateHasProfile) {
                    CandidateProfile::create([
                        'student_id' => $candidate->student_id,
                        'bio' => $bio,
                        'catch_phrase' => $catchPhrase,
                        'contact' => $contact,
                        'profile_url' => $profile_url,
                    ]);
                } else {
                    CandidateProfile::where('student_id', $candidate->student_id)
                        ->update(['profile_url' => $profile_url]);
                }
            }
        }
    }

    public function imageProvider($candidateId, $srcPostId)
    {
        //get candidate gender
        $candidateGender = $this->gender($candidateId);

        switch ($candidateGender) {
            case StudentConstants::FEMALE:
                if ($srcPostId === SrcPostConstants::PRESIDENT['src_post_id']) {
                    $candidateImgs = $this->findUsedImgs($srcPostId, $candidateId, $candidateGender);
                    return $this->getUnusedImg($candidateImgs, CandidateProfileConstants::FEMALE_PRESIDENT_IMGS);
                } else {
                    return $this->imageConfig($candidateGender, $this->femaleImgCount, CandidateProfileConstants::FEMALE_PRESIDENT_IMGS);
                }

            case StudentConstants::MALE:
                if ($srcPostId === SrcPostConstants::PRESIDENT['src_post_id']) {
                    $candidateImgs = $this->findUsedImgs($srcPostId, $candidateId, $candidateGender);
                    return $this->getUnusedImg($candidateImgs, CandidateProfileConstants::MALE_PRESIDENT_IMGS);
                } else {
                    return $this->imageConfig($candidateGender, $this->maleImgCount, CandidateProfileConstants::MALE_PRESIDENT_IMGS);
                }
        }
    }

    public function imageConfig($candidateGender, $genderImgCount, $genderImgs)
    {
        $localGenderImgCount = $genderImgCount;

        while (true) {
            $image = strtolower($candidateGender) . '-' . $localGenderImgCount . '.jpg';

            if (in_array($image, $genderImgs)) {
                $localGenderImgCount += 1;
            } else {
                $localGenderImgCount += 1;

                switch ($candidateGender) {
                    case StudentConstants::FEMALE:
                        $this->femaleImgCount = $localGenderImgCount;
                        break;
                    case StudentConstants::MALE:
                        $this->maleImgCount = $localGenderImgCount;
                        break;
                }
                return $image;
            }
        }
    }

    public function findUsedImgs($srcPostId, $candidateId, $gender)
    {
        $candidateService = new CandidateService();
        $candidates = $candidateService->getCandidatesBySrcPostId($srcPostId);
        $candidatesByGender = [];
        $candidateImgs = [];

        foreach ($candidates as $candidate) {
            $candidateGender = $this->gender($candidate->student_id);
            if ($candidateId == $candidate->student_id) continue;
            else {
                if ($candidateGender == $gender) $candidatesByGender[] = $candidate;
            }
        }

        //check the name of the image used
        if (count($candidatesByGender)) {
            foreach ($candidatesByGender as $candidate) {
                $candidateHasProfile = CandidateProfile::where('student_id', $candidate->student_id)->exists();

                switch ($candidateHasProfile) {
                    case true:
                        $candidateRawUrl = $candidateService->getCandidateProfileUrl($candidate->student_id);
                        $candidateImgs[] = explode('\\', $candidateRawUrl->profile_url)[1];
                        break;
                    case false:
                        break;
                }
            }
        }

        return $candidateImgs;
    }

    public function getUnusedImg($candidateImgs, $genericImgs)
    {
        if (count($candidateImgs)) {
            foreach ($genericImgs as $img) {
                if (!in_array($img, $candidateImgs)) return $img;
            }
        }

        return $genericImgs[0];
    }
}
