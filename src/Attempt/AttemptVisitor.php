<?php

namespace TMciver\Functional\Attempt;

interface AttemptVisitor {

    function visitFailure($failure);

    function visitSuccess($success);
}
