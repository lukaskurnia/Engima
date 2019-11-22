chmod 400 $aws_pem
ssh -o "StrictHostKeyChecking=no" -i $aws_pem $aws_user@$aws_ip "rm -rf engima"
ssh -o "StrictHostKeyChecking=no" -i $aws_pem $aws_user@$aws_ip "mkdir engima"
scp -o "StrictHostKeyChecking=no" -i $aws_pem * $aws_user@$aws_ip:~/engima