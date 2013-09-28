cqrs-php
========
This package helps implementing the Command Query Responsibility Segregation (CQRS) principles for php applications.
CQRS plays well with Domain Driven Design (DDD). 

The package sends commands to a bus-system. These commands on the other side are executed by handlers (or services) that registered interest on them. Once executed the handler transforms the command into a event and dispatches it back to a bus.

## Overview
