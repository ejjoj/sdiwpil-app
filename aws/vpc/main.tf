resource "aws_vpc" "main" {
    cidr_block = "10.0.0.0/16"

    enable_dns_support   = true
    enable_dns_hostnames = true

    tags = {
        Name = "main-vpc"
    }
}

resource "aws_subnet" "public_subnet_1" {
    vpc_id            = aws_vpc.main.id
    cidr_block        = "10.0.1.0/24"
    map_public_ip_on_launch = true

    tags = {
        Name = "public-subnet-1"
    }
}

resource "aws_subnet" "public_subnet_2" {
    vpc_id            = aws_vpc.main.id
    cidr_block        = "10.0.2.0/24"
    map_public_ip_on_launch = true

    tags = {
        Name = "public-subnet-2"
    }
}
