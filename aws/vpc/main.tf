resource "aws_vpc" "main" {
    cidr_block = "10.0.0.0/16"
}

resource "aws_subnet" "public_subnet_1" {
    vpc_id            = aws_vpc.main.id
    cidr_block        = "10.0.1.0/24"
    map_public_ip_on_launch = true
    availability_zone = "eu-north-1a"
}

resource "aws_subnet" "public_subnet_2" {
    vpc_id            = aws_vpc.main.id
    cidr_block        = "10.0.2.0/24"
    map_public_ip_on_launch = true
    availability_zone = "eu-north-1b"
}

resource "aws_internet_gateway" "igw" {
    vpc_id = aws_vpc.main.id
}

resource "aws_route_table" "public" {
    vpc_id = aws_vpc.main.id

    route {
        cidr_block = "0.0.0.0/0"
        gateway_id = aws_internet_gateway.igw.id
    }
}

resource "aws_route_table_association" "public_a" {
    subnet_id      = aws_subnet.public_subnet_1.id
    route_table_id = aws_route_table.public.id
}

resource "aws_route_table_association" "public_b" {
    subnet_id      = aws_subnet.public_subnet_2.id
    route_table_id = aws_route_table.public.id
}
