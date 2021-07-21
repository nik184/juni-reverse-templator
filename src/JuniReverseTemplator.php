<?php

namespace JuniReverseTemplator;

class JuniReverseTemplator {

    /**
     * @throws ResultTemplateMismatchException
     * @throws InvalidTemplateException
     */
    public function reverse(string $template, string $result): array {

        if (!$this->isTokensRangeValid($template)) throw new InvalidTemplateException();

        $templateRegex = preg_replace("/({{1,2})[^}{]*(}{1,2})/", "($1.*$2)", $template);
        $resultRegex = preg_replace("/{{1,2}[^}{]*}{1,2}/", "(.*)", $template);
        preg_match_all("/" . $templateRegex . "/", $template, $templateMatches);
        preg_match_all("/" . $resultRegex . "/", $result, $resultMatches);

        if (!$resultMatches[0]) throw new ResultTemplateMismatchException();

        $resultArray = [];

        for ($i = 1; $i < count($templateMatches); $i++) {
            $name = $templateMatches[$i][0];
            $val = (preg_match('/{{.*}}/', $name)) ? htmlspecialchars_decode($resultMatches[$i][0]) : $resultMatches[$i][0];
            $resultArray[trim($name, "{} \n\r\t\v\0")] = $val;
        }

        return $resultArray;
    }

    private function isTokensRangeValid($template) {
        preg_match_all("/({{)|(}})|({)|(})/", $template, $tokensArray);

        $currentToken = "";
        foreach ($tokensArray[0] as $item) {
            if ( ($item === "{" || $item === "{{") && $currentToken === "") {
                $currentToken = $item;
                continue;
            }

            if ($item === "}" && $currentToken === "{") {
                $currentToken = "";
                continue;
            }

            if ($item === "}}" && $currentToken === "{{") {
                $currentToken = "";
                continue;
            }

            return false;
        }

        return true;
    }
}