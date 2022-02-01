<?php

class Job
{
    private $data;
    public $title;
    public $posted_date;
    public $company;
    public $rating;
    public $location;
    public $salary;
    public $url = 'https://www.indeed.com';
    public $description;

    public function __construct($data)
    {
        $this->data = $data;
        $this->title = $this->getTitle();
        $this->posted_date = $this->getPostedDate();
        $this->company = $this->getCompanyName();
        $this->rating = $this->getCompanyRating();
        $this->location = $this->getLocation();
        $this->salary = $this->getSalary();
        $this->url .= $this->getUrl();
        $this->description = $this->getDescription();
    }

    private function getTitle()
    {
        return strip_tags(get_string_between($this->data, '<span title="', '"'));
    }

    private function getPostedDate()
    {
        $date = get_string_between($this->data, '<span class="date">', '<button');
        return strip_tags(get_string_between($date, '</span>', '</span>'));
    }

    private function getCompanyContent()
    {
        return get_string_between($this->data, '<span class="companyName">', '</span>');
    }

    private function getCompanyName()
    {
        return strip_tags(get_string_between($this->getCompanyContent(), 'rel="noopener">', '</a>'));
    }

    private function getCompanyRating()
    {
        return strip_tags(get_string_between(get_string_between($this->data, '"ratingNumber"', '/span>'), '"true">', '<'));
    }

    private function getLocation()
    {
        $location =  strip_tags(get_string_between($this->data, '<div class="companyLocation">', '</div>'));
        $plus = strpos($location, '+');
        return $plus === false ? $location : substr($location, 0, $plus);
    }

    private function getSalary()
    {
        return strip_tags(get_string_between($this->data, '="evenodd"></path></svg>', '</div>'));
    }

    private function getUrl()
    {
        return get_string_between($this->data, 'href="', '"');
    }

    private function getDescription()
    {
        $desc = get_string_between($this->data, '<div class="job-snippet">', '</div>');
        $desc = get_string_between($desc, '">', '</ul>');

        return trim(strip_tags($desc));
    }
}