<?php

namespace App\Models\_Traits\Search;

trait Search
{
    /**
     * @param string $term
     *
     * @return string
     */
    protected function wildCards(string $term = '') : string
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach($words as $key => $word) {
            if(strlen($word) >= 3) {
                $words[$key] = '+' . $word . '*';
            }
        }

        $searchTerm = implode( ' ', $words);

        return $searchTerm;
    }

    public function scopeSearch($query,  string $term = '', $selectAll = false)
    {
        if(strlen($term) == 0)
            return $query;

        $columns = implode(',', $this->searchable);

        $searchableTerm = $this->wildCards($term);
        $sq = $selectAll ? '' : '*,';
        $query->selectRaw("{$sq} MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE) AS relevance_score", [$searchableTerm])
              ->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $searchableTerm)
              ->orderByDesc('relevance_score');

        return $query;
    }
}