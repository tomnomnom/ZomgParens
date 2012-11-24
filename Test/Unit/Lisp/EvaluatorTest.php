<?php
namespace Test\Unit\Lisp;

class EvaluatorTest extends \PHPUnit_Framework_TestCase {
  
  protected function getSymbolTable(){
    $tf = new \Lisp\TypeFactory();
    $symbols = new \Lisp\SymbolTable([
      '+' => function($a, $b) use($tf){
        return $tf->makeScalar($a->value() + $b->value());
      },
      '-' => function($a, $b) use($tf){
        return $tf->makeScalar($a->value() - $b->value());
      }
    ]);

    return $symbols;
  }

  public function testBasic(){
    $tree = [
      new \Lisp\Type\Sexp([
        new \Lisp\Type\Symbol('+'),
        new \Lisp\Type\Scalar\Integer('2'),
        new \Lisp\Type\Scalar\Integer('3')
      ])
    ];

    $symbols = $this->getSymbolTable();
    $e = new \Lisp\Evaluator($tree, $symbols); 

    $e->evaluate();

    $this->assertEquals(5, $e->lastReturnValue()->evaluate(), "Last return value should have been 5");
  }
}
