<?php

namespace PhatCats\Attempt;

interface AttemptVisitor {

    function visitFailure($failure);

    function visitSuccess($success);
}
