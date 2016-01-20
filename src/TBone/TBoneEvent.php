<?php

namespace TBone;

class TBoneEvent
{
    /**
     * A matching route was not found.
     */
    const ROUTE_NOT_FOUND = 1;
    const ROUTE_DISPATCH_REQUESTED = 2;
    const ROUTE_DISPATCHED = 3;
}
