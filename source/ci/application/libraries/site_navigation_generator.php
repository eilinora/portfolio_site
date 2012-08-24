<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Site_Navigation_Generator {

  protected function cleanString ($str) {
    $str = str_replace('&', 'and', $str);
    $str = preg_replace('/[^a-zA-Z\-0-9\s]/','', $str);
    $str = str_replace(' ', '-', $str);
    return $str;
  }

  public function createAuthorIndexURL ($letter) {
    return '/authors/'.$this->cleanString(strtolower($letter));
  }

  public function createBookURL ($bookTitle, $bookISBN) {
    return '/book/'.$this->cleanString($bookTitle).'/'.$bookISBN;
  }

  public function createAuthorURL($authorName, $authorID) {
    return '/author/'.$this->cleanString($authorName).'/'.$authorID;
  }
}

/* End of file WPAccessorLibrary.php */