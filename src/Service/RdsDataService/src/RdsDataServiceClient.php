<?php

namespace AsyncAws\RdsDataService;

use AsyncAws\Core\AbstractApi;
use AsyncAws\Core\AwsError\AwsErrorFactoryInterface;
use AsyncAws\Core\AwsError\JsonRestAwsErrorFactory;
use AsyncAws\Core\Configuration;
use AsyncAws\Core\RequestContext;
use AsyncAws\RdsDataService\Enum\RecordsFormatType;
use AsyncAws\RdsDataService\Exception\AccessDeniedException;
use AsyncAws\RdsDataService\Exception\BadRequestException;
use AsyncAws\RdsDataService\Exception\ForbiddenException;
use AsyncAws\RdsDataService\Exception\InternalServerErrorException;
use AsyncAws\RdsDataService\Exception\NotFoundException;
use AsyncAws\RdsDataService\Exception\ServiceUnavailableErrorException;
use AsyncAws\RdsDataService\Exception\StatementTimeoutException;
use AsyncAws\RdsDataService\Input\BatchExecuteStatementRequest;
use AsyncAws\RdsDataService\Input\BeginTransactionRequest;
use AsyncAws\RdsDataService\Input\CommitTransactionRequest;
use AsyncAws\RdsDataService\Input\ExecuteStatementRequest;
use AsyncAws\RdsDataService\Input\RollbackTransactionRequest;
use AsyncAws\RdsDataService\Result\BatchExecuteStatementResponse;
use AsyncAws\RdsDataService\Result\BeginTransactionResponse;
use AsyncAws\RdsDataService\Result\CommitTransactionResponse;
use AsyncAws\RdsDataService\Result\ExecuteStatementResponse;
use AsyncAws\RdsDataService\Result\RollbackTransactionResponse;
use AsyncAws\RdsDataService\ValueObject\ResultSetOptions;
use AsyncAws\RdsDataService\ValueObject\SqlParameter;

class RdsDataServiceClient extends AbstractApi
{
    /**
     * Runs a batch SQL statement over an array of data.
     *
     * @see https://docs.aws.amazon.com/rdsdataservice/latest/APIReference/API_BatchExecuteStatement.html
     * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-rds-data-2018-08-01.html#batchexecutestatement
     *
     * @param array{
     *   resourceArn: string,
     *   secretArn: string,
     *   sql: string,
     *   database?: string,
     *   schema?: string,
     *   parameterSets?: array[],
     *   transactionId?: string,
     *   @region?: string,
     * }|BatchExecuteStatementRequest $input
     *
     * @throws AccessDeniedException
     * @throws BadRequestException
     * @throws StatementTimeoutException
     * @throws InternalServerErrorException
     * @throws ForbiddenException
     * @throws ServiceUnavailableErrorException
     */
    public function batchExecuteStatement($input): BatchExecuteStatementResponse
    {
        $input = BatchExecuteStatementRequest::create($input);
        $response = $this->getResponse($input->request(), new RequestContext(['operation' => 'BatchExecuteStatement', 'region' => $input->getRegion(), 'exceptionMapping' => [
            'AccessDeniedException' => AccessDeniedException::class,
            'BadRequestException' => BadRequestException::class,
            'StatementTimeoutException' => StatementTimeoutException::class,
            'InternalServerErrorException' => InternalServerErrorException::class,
            'ForbiddenException' => ForbiddenException::class,
            'ServiceUnavailableError' => ServiceUnavailableErrorException::class,
        ]]));

        return new BatchExecuteStatementResponse($response);
    }

    /**
     * Starts a SQL transaction.
     *
     * @see https://docs.aws.amazon.com/rdsdataservice/latest/APIReference/API_BeginTransaction.html
     * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-rds-data-2018-08-01.html#begintransaction
     *
     * @param array{
     *   resourceArn: string,
     *   secretArn: string,
     *   database?: string,
     *   schema?: string,
     *   @region?: string,
     * }|BeginTransactionRequest $input
     *
     * @throws AccessDeniedException
     * @throws BadRequestException
     * @throws StatementTimeoutException
     * @throws InternalServerErrorException
     * @throws ForbiddenException
     * @throws ServiceUnavailableErrorException
     */
    public function beginTransaction($input): BeginTransactionResponse
    {
        $input = BeginTransactionRequest::create($input);
        $response = $this->getResponse($input->request(), new RequestContext(['operation' => 'BeginTransaction', 'region' => $input->getRegion(), 'exceptionMapping' => [
            'AccessDeniedException' => AccessDeniedException::class,
            'BadRequestException' => BadRequestException::class,
            'StatementTimeoutException' => StatementTimeoutException::class,
            'InternalServerErrorException' => InternalServerErrorException::class,
            'ForbiddenException' => ForbiddenException::class,
            'ServiceUnavailableError' => ServiceUnavailableErrorException::class,
        ]]));

        return new BeginTransactionResponse($response);
    }

    /**
     * Ends a SQL transaction started with the `BeginTransaction` operation and commits the changes.
     *
     * @see https://docs.aws.amazon.com/rdsdataservice/latest/APIReference/API_CommitTransaction.html
     * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-rds-data-2018-08-01.html#committransaction
     *
     * @param array{
     *   resourceArn: string,
     *   secretArn: string,
     *   transactionId: string,
     *   @region?: string,
     * }|CommitTransactionRequest $input
     *
     * @throws AccessDeniedException
     * @throws BadRequestException
     * @throws StatementTimeoutException
     * @throws InternalServerErrorException
     * @throws ForbiddenException
     * @throws ServiceUnavailableErrorException
     * @throws NotFoundException
     */
    public function commitTransaction($input): CommitTransactionResponse
    {
        $input = CommitTransactionRequest::create($input);
        $response = $this->getResponse($input->request(), new RequestContext(['operation' => 'CommitTransaction', 'region' => $input->getRegion(), 'exceptionMapping' => [
            'AccessDeniedException' => AccessDeniedException::class,
            'BadRequestException' => BadRequestException::class,
            'StatementTimeoutException' => StatementTimeoutException::class,
            'InternalServerErrorException' => InternalServerErrorException::class,
            'ForbiddenException' => ForbiddenException::class,
            'ServiceUnavailableError' => ServiceUnavailableErrorException::class,
            'NotFoundException' => NotFoundException::class,
        ]]));

        return new CommitTransactionResponse($response);
    }

    /**
     * Runs a SQL statement against a database.
     *
     * @see https://docs.aws.amazon.com/rdsdataservice/latest/APIReference/API_ExecuteStatement.html
     * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-rds-data-2018-08-01.html#executestatement
     *
     * @param array{
     *   resourceArn: string,
     *   secretArn: string,
     *   sql: string,
     *   database?: string,
     *   schema?: string,
     *   parameters?: SqlParameter[],
     *   transactionId?: string,
     *   includeResultMetadata?: bool,
     *   continueAfterTimeout?: bool,
     *   resultSetOptions?: ResultSetOptions|array,
     *   formatRecordsAs?: RecordsFormatType::*,
     *   @region?: string,
     * }|ExecuteStatementRequest $input
     *
     * @throws AccessDeniedException
     * @throws BadRequestException
     * @throws StatementTimeoutException
     * @throws InternalServerErrorException
     * @throws ForbiddenException
     * @throws ServiceUnavailableErrorException
     */
    public function executeStatement($input): ExecuteStatementResponse
    {
        $input = ExecuteStatementRequest::create($input);
        $response = $this->getResponse($input->request(), new RequestContext(['operation' => 'ExecuteStatement', 'region' => $input->getRegion(), 'exceptionMapping' => [
            'AccessDeniedException' => AccessDeniedException::class,
            'BadRequestException' => BadRequestException::class,
            'StatementTimeoutException' => StatementTimeoutException::class,
            'InternalServerErrorException' => InternalServerErrorException::class,
            'ForbiddenException' => ForbiddenException::class,
            'ServiceUnavailableError' => ServiceUnavailableErrorException::class,
        ]]));

        return new ExecuteStatementResponse($response);
    }

    /**
     * Performs a rollback of a transaction. Rolling back a transaction cancels its changes.
     *
     * @see https://docs.aws.amazon.com/rdsdataservice/latest/APIReference/API_RollbackTransaction.html
     * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-rds-data-2018-08-01.html#rollbacktransaction
     *
     * @param array{
     *   resourceArn: string,
     *   secretArn: string,
     *   transactionId: string,
     *   @region?: string,
     * }|RollbackTransactionRequest $input
     *
     * @throws AccessDeniedException
     * @throws BadRequestException
     * @throws StatementTimeoutException
     * @throws InternalServerErrorException
     * @throws ForbiddenException
     * @throws ServiceUnavailableErrorException
     * @throws NotFoundException
     */
    public function rollbackTransaction($input): RollbackTransactionResponse
    {
        $input = RollbackTransactionRequest::create($input);
        $response = $this->getResponse($input->request(), new RequestContext(['operation' => 'RollbackTransaction', 'region' => $input->getRegion(), 'exceptionMapping' => [
            'AccessDeniedException' => AccessDeniedException::class,
            'BadRequestException' => BadRequestException::class,
            'StatementTimeoutException' => StatementTimeoutException::class,
            'InternalServerErrorException' => InternalServerErrorException::class,
            'ForbiddenException' => ForbiddenException::class,
            'ServiceUnavailableError' => ServiceUnavailableErrorException::class,
            'NotFoundException' => NotFoundException::class,
        ]]));

        return new RollbackTransactionResponse($response);
    }

    protected function getAwsErrorFactory(): AwsErrorFactoryInterface
    {
        return new JsonRestAwsErrorFactory();
    }

    protected function getEndpointMetadata(?string $region): array
    {
        if (null === $region) {
            $region = Configuration::DEFAULT_REGION;
        }

        switch ($region) {
            case 'fips-us-east-1':
                return [
                    'endpoint' => 'https://rds-data-fips.us-east-1.amazonaws.com',
                    'signRegion' => 'us-east-1',
                    'signService' => 'rds-data',
                    'signVersions' => ['v4'],
                ];
            case 'fips-us-east-2':
                return [
                    'endpoint' => 'https://rds-data-fips.us-east-2.amazonaws.com',
                    'signRegion' => 'us-east-2',
                    'signService' => 'rds-data',
                    'signVersions' => ['v4'],
                ];
            case 'fips-us-west-1':
                return [
                    'endpoint' => 'https://rds-data-fips.us-west-1.amazonaws.com',
                    'signRegion' => 'us-west-1',
                    'signService' => 'rds-data',
                    'signVersions' => ['v4'],
                ];
            case 'fips-us-west-2':
                return [
                    'endpoint' => 'https://rds-data-fips.us-west-2.amazonaws.com',
                    'signRegion' => 'us-west-2',
                    'signService' => 'rds-data',
                    'signVersions' => ['v4'],
                ];
        }

        return [
            'endpoint' => "https://rds-data.$region.amazonaws.com",
            'signRegion' => $region,
            'signService' => 'rds-data',
            'signVersions' => ['v4'],
        ];
    }
}
