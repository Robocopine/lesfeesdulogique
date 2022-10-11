<?php

namespace App\Service;

use Twig\Environment;
use Symfony\Component\HttpFoundation\RequestStack;

class LanguageService {
    public function __construct(RequestStack $request, $templatePath, Environment $twig){
        $this->language = $request ->getCurrentRequest()->attributes->get('_locale');
        $this->route = $request->getCurrentRequest()->attributes->get('_route');
        $this->templatePath = $templatePath;
        $this->twig = $twig;
    }

    public function getLanguage() {
        if($this->language == null or $this->language != ('nl' or 'en' or 'de' or 'fr')){ $this->language = 'fr'; }
        return $this->language;
    }

    public function setLanguage($language) {
        $this->language = $language;
    
        return $this;
    }

    public function getRoute() {
        return $this->route;
    }
    
    public function setRoute($route) {
    
        $this->route = $route;
    
        return $this;
    }

    public function getTemplatePath(){
        return $this->templatePath;
    }
    
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
    
        return $this;
    }

    public function display() {

        $this->twig->display($this->templatePath, [
          'route' => $this->route,
          'lg' => $this->language,
        ]);
  
    }
    
}