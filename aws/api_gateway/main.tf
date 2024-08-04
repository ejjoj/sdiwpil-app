resource "aws_api_gateway_rest_api" "api" {
  name        = "microservices-api"
  description = "API Gateway for microservices"
}

resource "aws_api_gateway_resource" "customer_resource" {
  rest_api_id = aws_api_gateway_rest_api.api.id
  parent_id   = aws_api_gateway_rest_api.api.root_resource_id
  path_part   = "customer"
}

resource "aws_api_gateway_method" "customer_method" {
  rest_api_id   = aws_api_gateway_rest_api.api.id
  resource_id   = aws_api_gateway_resource.customer_resource.id
  http_method   = "ANY"
  authorization = "NONE"
}

resource "aws_api_gateway_integration" "customer_integration" {
  rest_api_id             = aws_api_gateway_rest_api.api.id
  resource_id             = aws_api_gateway_resource.customer_resource.id
  http_method             = aws_api_gateway_method.customer_method.http_method
  type                    = "HTTP_PROXY"
  integration_http_method = "ANY"
  uri                     = var.customer_service_endpoint
}

resource "aws_api_gateway_resource" "appointment_resource" {
  rest_api_id = aws_api_gateway_rest_api.api.id
  parent_id   = aws_api_gateway_rest_api.api.root_resource_id
  path_part   = "appointment"
}

resource "aws_api_gateway_method" "appointment_method" {
  rest_api_id   = aws_api_gateway_rest_api.api.id
  resource_id   = aws_api_gateway_resource.appointment_resource.id
  http_method   = "ANY"
  authorization = "NONE"
}

resource "aws_api_gateway_integration" "appointment_integration" {
  rest_api_id             = aws_api_gateway_rest_api.api.id
  resource_id             = aws_api_gateway_resource.appointment_resource.id
  http_method             = aws_api_gateway_method.appointment_method.http_method
  type                    = "HTTP_PROXY"
  integration_http_method = "ANY"
  uri                     = var.appointment_service_endpoint
}

resource "aws_api_gateway_resource" "doctor_resource" {
  rest_api_id = aws_api_gateway_rest_api.api.id
  parent_id   = aws_api_gateway_rest_api.api.root_resource_id
  path_part   = "doctor"
}

resource "aws_api_gateway_method" "doctor_method" {
  rest_api_id   = aws_api_gateway_rest_api.api.id
  resource_id   = aws_api_gateway_resource.doctor_resource.id
  http_method   = "ANY"
  authorization = "NONE"
}

resource "aws_api_gateway_integration" "doctor_integration" {
  rest_api_id             = aws_api_gateway_rest_api.api.id
  resource_id             = aws_api_gateway_resource.doctor_resource.id
  http_method             = aws_api_gateway_method.doctor_method.http_method
  type                    = "HTTP_PROXY"
  integration_http_method = "ANY"
  uri                     = var.doctor_service_endpoint
}

resource "aws_api_gateway_resource" "patient_resource" {
  rest_api_id = aws_api_gateway_rest_api.api.id
  parent_id   = aws_api_gateway_rest_api.api.root_resource_id
  path_part   = "patient"
}

resource "aws_api_gateway_method" "patient_method" {
  rest_api_id   = aws_api_gateway_rest_api.api.id
  resource_id   = aws_api_gateway_resource.patient_resource.id
  http_method   = "ANY"
  authorization = "NONE"
}

resource "aws_api_gateway_integration" "patient_integration" {
  rest_api_id             = aws_api_gateway_rest_api.api.id
  resource_id             = aws_api_gateway_resource.patient_resource.id
  http_method             = aws_api_gateway_method.patient_method.http_method
  type                    = "HTTP_PROXY"
  integration_http_method = "ANY"
  uri                     = var.patient_service_endpoint
}
