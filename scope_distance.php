public function scopeIsWithinMaxDistance($query, $latitude, $longitude, $distance_type = 'miles', $radius = 10)
    {
        $wRadius = $distance_type == 'miles' ? '3961' : '6371';
        $haversine = "($wRadius * acos(cos(radians($latitude))
                    * cos(radians(latitude))
                    * cos(radians(longitude)
                    - radians($longitude))
                    + sin(radians($latitude))
                    * sin(radians(latitude))))";
        return $query
            ->select('*') //pick the columns you want here.
            ->selectRaw("{$haversine} AS distance")
            ->whereRaw("{$haversine} < ?", [$radius]);
    }
