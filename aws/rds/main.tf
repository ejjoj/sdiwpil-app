resource "aws_db_instance" "sdiwpil_db" {
    allocated_storage    = 20
    storage_type         = "gp2"
    engine               = "postgres"
    engine_version       = "13.3"
    instance_class       = "db.t3.micro"
    username             = "admin"
    password             = "password"
    db_subnet_group_name = aws_db_subnet_group.default.name
    vpc_security_group_ids = [aws_security_group.rds.id]
    skip_final_snapshot  = true
}

resource "aws_db_subnet_group" "default" {
    name       = "main"
    subnet_ids = var.subnet_ids
}

resource "aws_security_group" "rds" {
    name        = "rds-sg"
    vpc_id      = var.vpc_id

    ingress {
        from_port   = 5432
        to_port     = 5432
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
