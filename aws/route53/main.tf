resource "aws_route53_zone" "primary" {
    name = "sdiwpil.com"
}

resource "aws_route53_record" "api" {
    zone_id = aws_route53_zone.primary.zone_id
    name    = "api.sdiwpil.com"
    type    = "CNAME"
    ttl     = 300
    records = [var.api_gateway_id]
}
