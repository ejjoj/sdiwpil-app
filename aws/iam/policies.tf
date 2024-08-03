resource "aws_iam_policy_attachment" "ecs_task_execution_role_policy" {
    roles      = aws_iam_role.ecs_task_execution_role.name
    policy_arn = "arn:aws:iam::aws:policy/service-role/AmazonECSTaskExecutionRolePolicy"
    name       = "ecs_task_execution_role_policy"
}

resource "aws_iam_policy_attachment" "ecs_task_role_policy" {
    roles      = aws_iam_role.ecs_task_role.name
    policy_arn = "arn:aws:iam::aws:policy/AmazonECSTaskRolePolicy"
    name       = "ecs_task_role_policy"
}
