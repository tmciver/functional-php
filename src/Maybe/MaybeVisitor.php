<?php

namespace TMciver\Functional\Maybe;

interface MaybeVisitor {

    function visitNothing($nothing);

    function visitJust($just);
}
