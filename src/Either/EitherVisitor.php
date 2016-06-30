<?php

namespace TMciver\Functional\Either;

interface EitherVisitor {

    function visitLeft($left);

    function visitRight($right);
}
