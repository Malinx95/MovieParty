<?php
/*
* objet qui gere l'api allocine
*/
class Allocine
{
    private $_api_url = 'https://graph.allocine.fr/v1/mobile/';
    private $_token;
    private $_user_token;

    /*
    * fonction qui initialise les identifiants
    */
    public function __construct()
    {
        // $this->_token = 'cdzJ4OwAJZc:APA91bGIHnUKMixd8xxrV-xedwZYSVcllJ3uXHs2PVriELPfxYBjN7JWyTiOfSmata__TFoD18FoC16SmkEASiWbg6mRqO2vvDESPiumsxsz5puWWgoaHR52f2KHY923dDMVbOBVbi4k';
        $this->_token = 'c4O6_g8tU74:APA91bF2NxCVPnWjh28JmIG1MOR46BLg-YqZOyG1dpA9bc1m7SrB99GBBryokSmdYTL11WoW-bUS0pQmu2D2Y_9KwoWZW3x6UH4nl5GOIOpyvefse-E7vwsiKStN3ncSRmjWsdR8rK7b';
        $this->_user_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NzE4NDM5NTcsInVzZXJuYW1lIjoiYW5vbnltb3VzIiwiYXBwbGljYXRpb25fbmFtZSI6Im1vYmlsZSIsInV1aWQiOiJmMDg3YTZiZi05YTdlLTQ3YTUtYjc5YS0zMDNiNWEwOWZkOWYiLCJzY29wZSI6bnVsbCwiZXhwIjoxNjg2NzAwNzk5fQ.oRS_jzmvfFAQ47wH0pU3eKKnlCy93FhblrBXxPZx2iwUUINibd70MBkI8C8wmZ-AeRhVCR8kavW8dLIqs5rUfA6piFwdYpt0lsAhTR417ABOxVrZ8dv0FX3qg1JLIzan-kSN4TwUZ3yeTjls0PB3OtSBKzoywGvFAu2jMYG1IZyBjxnkfi1nf1qGXbYsBfEaSjrj-LDV6Jjq_MPyMVvngNYKWzFNyzVAKIpAZ-UzzAQujAKwNQcg2j3Y3wfImydZEOW_wqkOKCyDOw9sWCWE2D-SObbFOSrjqKBywI-Q9GlfsUz-rW7ptea_HzLnjZ9mymXc6yq7KMzbgG4W9CZd8-qvHejCXVN9oM2RJ7Xrq5tDD345NoZ5plfCmhwSYA0DSZLw21n3SL3xl78fMITNQqpjlUWRPV8YqZA1o-UNgwMpOWIoojLWx-XBX33znnWlwSa174peZ1k60BQ3ZdCt9A7kyOukzvjNn3IOIVVgS04bBxl4holc5lzcEZSgjoP6dDIEJKib1v_AAxA34alVqWngeDYhd0wAO-crYW1HEd8ogtCoBjugwSy7526qrh68mSJxY66nr4Cle21z1wLC5lOsex0FbuwvOeFba0ycaI8NJPTUriOdvtHAjhDRSem4HjypGvKs5AzlZ3LAJACCHICNwo3NzYjcxfT4Wo1ur-M';
    }

    /*
    * fonction qui fait la query
    * @param $query
    *   requete
    */
    private function _do_request($query)
    {
        $data = ['query' => $query];
        $data = http_build_query($data);

        $headers = array();
        $headers[] = 'Authorization: Bearer ' . $this->_user_token;
        $headers[] = 'AC-Auth-Token: ' . $this->_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        return json_decode($result, true);
    }

    /*
    * fonction qui fait la requete et renvoi la reponse pour la liste de sceance
    * @param $id
    *   id du cinema
    * @param date
    *   date du jour pour les sceance
    */
    public function showtimelist($id, $date = null)
    {
        $id = base64_encode("Theater:" . $id);
        $query = <<<QUERY
        query {
          movieShowtimeList(theater: "$id", to: "$date", first: 100) {
            totalCount,
            edges {
              node {
                movie {
                  internalId
                  title
                  originalTitle
                  languages
                  synopsis
                  poster { url }
                  genres
                  format { audio , aspectRatios , filmGauges}
                  cast (first:3) {
                    edges {
                      node {
                        actor { stringValue }
                      }
                    }
                  }
                  credits(activity:DIRECTOR) {
                    edges {
                      node {
                        rank
                        person { stringValue }
                      }
                    }
                  }
                  runtime
                  countries { name }
                  mainRelease {
                    release {
                      releaseDate { date }
                    }
                  }
                  stats {
                    userRating {
                      score
                      count
                    }
                    pressReview {
                      score
                      count
                    }
                  }
                }
                showtimes {
                  startsAt
                  diffusionVersion
                  picture
                  languages
                  sound
                  timeBeforeStart
                  projection
                  experience
                  data {
                    ticketing {
                      urls
                      type
                      provider
                    }
                  }
                  isWeeklyMovieOuting
                }
              }
            }
          }
        }
        QUERY;

        // do the request
        $response = $this->_do_request($query);

        return $response;
    }
}