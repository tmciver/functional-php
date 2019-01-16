<?php

namespace PhatCats\Either;

interface EitherVisitor {

    function visitLeft($left);

    function visitRight($right);
}
