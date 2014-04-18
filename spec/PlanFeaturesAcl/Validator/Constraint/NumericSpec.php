<?php

namespace spec\PlanFeaturesAcl\Validator\Constraint;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NumericSpec extends ObjectBehavior
{
    function let(
        FeatureInterface $ltNumericFeature,
        FeatureInterface $waNumericFeature
    ) {

        $ltNumericFeature->getType()->willReturn('numeric');
        $ltNumericFeature->getValidationRules()->willReturn(json_encode(
            array(
                'lt' => array()
            )
        ));

        $waNumericFeature->getType()->willReturn('numeric');
        $waNumericFeature->getValidationRules()->willReturn(null);

    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PlanFeaturesAcl\Validator\Constraint\Numeric');
    }

    function it_should_throw_invalid_argument_exception_if_it_is_not_numeric(FeatureInterface $ltNumericFeature)
    {
        $this->shouldThrow('\InvalidArgumentException')
            ->duringValidate($ltNumericFeature, null);

        $this->shouldThrow('\InvalidArgumentException')
            ->duringValidate($ltNumericFeature, 'a string');
    }

    function it_should_validate_if_validation_rules_empty(FeatureInterface $waNumericFeature)
    {
        $this->validate($waNumericFeature, 0)->shouldReturn(true);
    }


    function it_should_process_lower_than_rule(FeatureInterface $ltNumericFeature)
    {
        $this->validate($ltNumericFeature, '10', '9')->shouldReturn(true);
        $this->validate($ltNumericFeature, '11.5', '11.4')->shouldReturn(true);

        $this->validate($ltNumericFeature, '10', '11')->shouldReturn(false);
        $this->validate($ltNumericFeature, '11.5', '11.5')->shouldReturn(false);
    }

    function it_should_process_lower_than_equal_rule(FeatureInterface $ltNumericFeature)
    {
        $this->validate($ltNumericFeature, '10', '9')->shouldReturn(true);
        $this->validate($ltNumericFeature, '11.5', '11.4')->shouldReturn(true);

        $this->validate($ltNumericFeature, '10', '11')->shouldReturn(false);
        $this->validate($ltNumericFeature, '11.5', '11.5')->shouldReturn(false);
    }

}
