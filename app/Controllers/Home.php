<?php

namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\ProjectModel;
use App\Models\MessageModel;

class Home extends BaseController
{
    public function index()
    {
        try {
            $settingsModel = new SettingsModel();
            $projectModel  = new ProjectModel();

            // Use simple findAll to avoid schema issues
            $projects = $projectModel->findAll();

            $data = [
                'settings' => $settingsModel->first(),
                'projects' => $projects,
            ];

            // Fallback default settings if db is empty for some reason
            if (!$data['settings']) {
                $data['settings'] = [
                    'tagline'     => 'Crafting spaces that tell your story.',
                    'description' => 'Specializing in warm minimalist and Japandi designs that blend high functionality with natural textures.',
                    'about_lead'  => 'My journey into interior design began with a simple belief.',
                    'about_body'  => 'I design with restraint, focusing on clean lines, organic textures.',
                    'about_quote' => 'The details are not the details. They make the design.',
                    'about_cite'  => '— Charles Eames',
                    'email'       => 'hello@jatin.designs',
                    'location'    => 'New Delhi, India'
                ];
            }

            return view('portfolio', $data);
        } catch (\Exception $e) {
            // If database fails, use fallback data
            $data = [
                'settings' => [
                    'tagline'     => 'Crafting spaces that tell your story.',
                    'description' => 'Specializing in warm minimalist and Japandi designs that blend high functionality with natural textures.',
                    'about_lead'  => 'My journey into interior design began with a simple belief.',
                    'about_body'  => 'I design with restraint, focusing on clean lines, organic textures.',
                    'about_quote' => 'The details are not the details. They make the design.',
                    'about_cite'  => '— Charles Eames',
                    'email'       => 'hello@jatin.designs',
                    'location'    => 'New Delhi, India'
                ],
                'projects' => []
            ];

            return view('portfolio', $data);
        }
    }

    public function submitContact()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name'         => 'required|min_length[3]',
                'email'        => 'required|valid_email',
                'project-type' => 'required',
                'message'      => 'required|min_length[5]'
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Please fill in all fields correctly.'
                ]);
            }

            $messageModel = new MessageModel();
            $messageModel->save([
                'name'         => $this->request->getPost('name'),
                'email'        => $this->request->getPost('email'),
                'project_type' => $this->request->getPost('project-type'),
                'message'      => $this->request->getPost('message')
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Thank you! Your message has been sent successfully.'
            ]);
        }

        return redirect()->to(base_url());
    }
}
