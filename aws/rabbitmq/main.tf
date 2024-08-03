resource "aws_instance" "rabbitmq" {
    ami                    = "ami-0c55b159cbfafe1f0"  # Zmienić na odpowiednią AMI
    instance_type          = "t3.micro"
    subnet_id              = var.subnet_ids[0]
    vpc_security_group_ids = [aws_security_group.rabbitmq.id]

    user_data = <<-EOF
              #!/bin/bash
              sudo apt-get update
              sudo apt-get install -y rabbitmq-server
              sudo systemctl enable rabbitmq-server
              sudo systemctl start rabbitmq-server
              EOF
}

resource "aws_security_group" "rabbitmq" {
    name        = "rabbitmq-sg"
    vpc_id      = var.vpc_id

    ingress {
        from_port   = 5672
        to_port     = 5672
        protocol    = "tcp"
        cidr_blocks = ["0.0.0.0/0"]
    }

    egress {
        from_port   = 0
        to_port     = 0
        protocol    = "-1"
        cidr_blocks = ["0.0.0.0/0"]
    }
}
