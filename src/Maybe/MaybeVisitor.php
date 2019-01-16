<?php

namespace PhatCats\Maybe;

interface MaybeVisitor {

    function visitNothing($nothing);

    function visitJust($just);
}
