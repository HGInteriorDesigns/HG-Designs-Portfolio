<?php

namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\ProjectModel;
use App\Models\MessageModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    private function checkAuth()
    {
        if (!$this->session->get('isLoggedIn')) {
            return false;
        }
        return true;
    }

    public function login()
    {
        if ($this->checkAuth()) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        $data = [];

        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('username', $username)->first();

            if ($user && password_verify($password, $user['password'])) {
                $this->session->set([
                    'username'   => $user['username'],
                    'isLoggedIn' => true,
                ]);
                return redirect()->to(base_url('admin/dashboard'));
            }

            $data['error'] = 'Invalid username or password';
        }

        return view('admin/login', $data);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('admin/login'));
    }

    public function dashboard()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('admin/login'));
        }

        $settingsModel = new SettingsModel();
        $projectModel  = new ProjectModel();
        $messageModel  = new MessageModel();

        $data = [
            'settings' => $settingsModel->first(),
            'projects' => $projectModel->findAll(),
            'messages' => $messageModel->orderBy('created_at', 'DESC')->findAll(),
            'success'  => $this->session->getFlashdata('success'),
            'error'    => $this->session->getFlashdata('error'),
        ];

        return view('admin/dashboard', $data);
    }

    public function saveSettings()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('admin/login'));
        }

        if ($this->request->getMethod() === 'post') {
            $settingsModel = new SettingsModel();
            $settings = $settingsModel->first();

            $updateData = [
                'tagline'     => $this->request->getPost('tagline'),
                'description' => $this->request->getPost('description'),
                'about_lead'  => $this->request->getPost('about_lead'),
                'about_body'  => $this->request->getPost('about_body'),
                'about_quote' => $this->request->getPost('about_quote'),
                'about_cite'  => $this->request->getPost('about_cite'),
                'email'       => $this->request->getPost('email'),
                'location'    => $this->request->getPost('location'),
            ];

            if ($settings) {
                $settingsModel->update($settings['id'], $updateData);
            } else {
                $settingsModel->insert($updateData);
            }

            $this->session->setFlashdata('success', 'Settings updated successfully.');
        }

        return redirect()->to(base_url('admin/dashboard'));
    }

    public function editProject($id = null)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('admin/login'));
        }

        $projectModel = new ProjectModel();
        $project = null;

        if ($id !== null) {
            $project = $projectModel->find($id);
            if (!$project) {
                $this->session->setFlashdata('error', 'Project not found.');
                return redirect()->to(base_url('admin/dashboard'));
            }
        }

        $data = [
            'project' => $project,
            'isEdit'  => ($id !== null),
            'errors'  => []
        ];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title'         => 'required',
                'slug'          => 'required',
                'description'   => 'required',
                'area'          => 'required',
                'location_name' => 'required',
                'materials'     => 'required',
            ];

            if ($this->validate($rules)) {
                $saveData = [
                    'title'         => $this->request->getPost('title'),
                    'slug'          => $this->request->getPost('slug'),
                    'description'   => $this->request->getPost('description'),
                    'area'          => $this->request->getPost('area'),
                    'location_name' => $this->request->getPost('location_name'),
                    'materials'     => $this->request->getPost('materials'),
                ];

                // Handle Image After Upload
                $imgAfter = $this->request->getFile('image_after');
                if ($imgAfter && $imgAfter->isValid() && !$imgAfter->hasMoved()) {
                    $newName = $imgAfter->getRandomName();
                    $imgAfter->move(FCPATH . 'assets', $newName);
                    $saveData['image_after'] = 'assets/' . $newName;
                } elseif ($project) {
                    $saveData['image_after'] = $project['image_after'];
                }

                // Handle Image Before Upload
                $imgBefore = $this->request->getFile('image_before');
                if ($imgBefore && $imgBefore->isValid() && !$imgBefore->hasMoved()) {
                    $newName = $imgBefore->getRandomName();
                    $imgBefore->move(FCPATH . 'assets', $newName);
                    $saveData['image_before'] = 'assets/' . $newName;
                } elseif ($project) {
                    $saveData['image_before'] = $project['image_before'];
                }

                if ($id !== null) {
                    $projectModel->update($id, $saveData);
                    $this->session->setFlashdata('success', 'Project updated successfully.');
                } else {
                    $projectModel->insert($saveData);
                    $this->session->setFlashdata('success', 'Project created successfully.');
                }

                return redirect()->to(base_url('admin/dashboard'));
            }

            $data['errors'] = $this->validator->getErrors();
        }

        return view('admin/edit_project', $data);
    }

    public function deleteProject($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('admin/login'));
        }

        $projectModel = new ProjectModel();
        if ($projectModel->find($id)) {
            $projectModel->delete($id);
            $this->session->setFlashdata('success', 'Project deleted successfully.');
        } else {
            $this->session->setFlashdata('error', 'Project not found.');
        }

        return redirect()->to(base_url('admin/dashboard'));
    }

    public function deleteMessage($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('admin/login'));
        }

        $messageModel = new MessageModel();
        if ($messageModel->find($id)) {
            $messageModel->delete($id);
            $this->session->setFlashdata('success', 'Message deleted successfully.');
        } else {
            $this->session->setFlashdata('error', 'Message not found.');
        }

        return redirect()->to(base_url('admin/dashboard'));
    }
}
