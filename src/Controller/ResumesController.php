<?php
declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;

class ResumesController extends AppController
{
    // Allowed designs. Each needs a templates/Resumes/pdf_<name>.php file.
    private const TEMPLATES = ['classic', 'modern', 'minimal'];

    // List the logged-in user's resumes.
    public function index()
    {
        $resumes = $this->Resumes->find()
            ->where(['Resumes.user_id' => $this->userId()])
            ->orderBy(['Resumes.created' => 'DESC'])
            ->all();
        $this->set(compact('resumes'));
    }

    // Show the form (GET) and save it (POST).
    public function add()
    {
        $resume = $this->Resumes->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Drop blank rows, then renumber keys 0,1,2...
            $data['experiences'] = array_values(array_filter(
                $data['experiences'] ?? [],
                fn($e) => !empty($e['company'])
            ));
            $data['educations'] = array_values(array_filter(
                $data['educations'] ?? [],
                fn($e) => !empty($e['school'])
            ));

            // Build the entity including nested jobs and schools.
            $resume = $this->Resumes->patchEntity($resume, $data, [
                'associated' => ['Experiences', 'Educations'],
            ]);

            // Owner comes from the session, never from the form.
            $resume->user_id = $this->userId();

            if (!in_array($resume->template, self::TEMPLATES, true)) {
                $resume->template = 'classic';
            }

            // Saves the resume plus its jobs and schools in one transaction.
            if ($this->Resumes->save($resume)) {
                return $this->redirect(['action' => 'view', $resume->id]);
            }
            $this->Flash->error('Please fix the errors and try again.');
        }

        $this->set(compact('resume'));
    }

    // "Resume ready" page.
    public function view($id)
    {
        $resume = $this->findOwned((int)$id);
        $this->set(compact('resume'));
    }

    // Generate the PDF and send it as a download.
    public function download($id)
{
    $resume = $this->findOwned((int)$id);

    $design = in_array($resume->template, self::TEMPLATES, true)
        ? $resume->template
        : 'classic';

    $this->set(compact('resume', 'design'));
    $this->viewBuilder()
        ->disableAutoLayout()
        ->setTemplatePath('Resumes')      // NEW: tells CakePHP to look in templates\Resumes\
        ->setTemplate('pdf');
    $html = $this->createView()->render();

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();

    return $this->response
        ->withType('pdf')
        ->withDownload('resume-' . $resume->id . '.pdf')
        ->withStringBody($dompdf->output());
}

    private function userId(): int
    {
        return (int)$this->Authentication->getIdentity()->getIdentifier();
    }

    // Finds a resume only if it belongs to the current user (404 otherwise).
    private function findOwned(int $id)
    {
        return $this->Resumes->find()
            ->where(['Resumes.id' => $id, 'Resumes.user_id' => $this->userId()])
            ->contain(['Experiences', 'Educations'])
            ->firstOrFail();
    }
}