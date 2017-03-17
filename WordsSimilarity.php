<?php


class WordsSimilarity {

    private $input;
    private $words = array();
    private $shortTest = -1;
    private $closestWord;

    public function __construct($words = array(), $input) {
        $this->words = $words;
        $this->input = strtolower($input);
    }

    public function checkWord() {
        foreach ($this->words as $word) {
            $levenshteinDistance = levenshtein($this->input, $word);

            if($levenshteinDistance == 0) {
                $this->closestWord = $word;
                $this->shortTest = 0;

                return true;
            }

            if ($levenshteinDistance <= $this->shortTest || $this->shortTest < 0) {
                $this->closestWord = $word;
                $this->shortTest = $levenshteinDistance;
            }
        }
        return false;
    }

    public function response() {
        if ($this->checkWord()) {
            return ['status' => true, 'message' => ''];
        } else {
            return ['status' => false, 'message' => 'Czy chodziło Ci o ' . $this->closestWord . '?'];
        }
    }
}