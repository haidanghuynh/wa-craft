<?php
class SettingController extends Controller
{
    public function index(): void
    {
        $model = new Setting();
        $settings = $model->getAllAsMap($this->lang);
        $this->jsonResponse($settings);
    }
}
