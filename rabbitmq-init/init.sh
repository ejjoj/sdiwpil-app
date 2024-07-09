#!/bin/bash
# Script to create the "messages" queue

rabbitmqadmin declare queue name=messages durable=true
