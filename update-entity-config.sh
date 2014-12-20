	php app/console oro:entity-config:update --env=prod;
	php app/console oro:entity-extend:update-config --env=prod;
	php app/console oro:entity-extend:update-schema --env=prod;
	php app/console doctrine:schema:update --force;
  	php app/console cache:clear --env=prod;
