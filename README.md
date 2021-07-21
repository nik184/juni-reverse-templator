## Reverse templator
Принцип работы класса JuniReverseTemplator показан в примере ниже
```PHP
$templator = new \JuniReverseTemplator\JuniReverseTemplator();

$template = 'hello, my name is {{name}}, i am {{job}}';
$result = 'hello, my name is Nik, i am programmer';
$variables = $templator->reverse($template, $result);

print_r($variables); // Array ( [name] => Nik [job] => programmer )
```



**Внимание!** В ситуации, когда невозможно одназначно определить, как распределен некоторый текст между несколькими переменными, он целиком будет помещен в первую из них.


```PHP
$templator = new \JuniReverseTemplator\JuniReverseTemplator();

$template = 'hello, i am {{name}}{{job}}{{age}}';
$result = 'hello, i am Nik, Programmer, 26 years old';
$variables = $templator->reverse($template, $result);

print_r($variables); // Array ( [name] => Nik, Programmer, 26 years old [job] => [age] => )
```
