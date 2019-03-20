<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\App;
use Modules\Contacts\Entities\Contact;
use Modules\Platform\Account\Service\UserMailService;
use Modules\Platform\Core\Repositories\GenericRepository;
use Stringy\Stringy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {



        $contactRepo = App::make(GenericRepository::class);
        $contactRepo->setupModel(Contact::class);

        $entity = $contactRepo->findWithoutFail(1);

        $this->assertTrue($entity != null && $entity->full_name != null);

        dump($entity->toArray());

        $template = "This is {{full_name}} {{job_title}}...";
        $data = $entity->toArray();

        if (preg_match_all("/{{(.*?)}}/", $template, $m)) {
            foreach ($m[1] as $i => $varname) {
                try {
                    $template = str_replace($m[0][$i], sprintf('%s', $data[$varname]), $template);
                }catch (\Exception  $exception){

                }
            }
        }

        dump($template);

       // Stringy::create($string)->replace


    }
}
