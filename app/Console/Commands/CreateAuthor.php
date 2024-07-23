<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CreateAuthorService;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CreateAuthor extends Command
{
    /**
     * Initialize construct.
     */
    public function __construct(public CreateAuthorService $createAuthorService)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new author';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $data = [
                'first_name' => $this->ask('Enter first name'),
                'last_name' => $this->ask('Enter last name'),
                'birthday' => $this->ask('Enter birthday (YYYY-MM-DD)'),
                'biography' => $this->ask('Enter biography'),
                'gender' => $this->anticipate('Enter gender', ['male', 'female']),
                'place_of_birth' => $this->ask('Enter place of birth'),
            ];

            $validator = Validator::make($data, [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'birthday' => 'required|date_format:Y-m-d',
                'biography' => 'required|string',
                'gender' => 'required|in:male,female,other',
                'place_of_birth' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                $this->error('Validation failed:');
                foreach ($validator->errors()->all() as $error) {
                    $this->error($error);
                }
                return 1;
            }
            $data['birthday'] = Carbon::parse($data['birthday']);

            $author = $this->createAuthorService->createAuthor($data);
            if ($author['error']) {
                $this->error('Error creating author: ' . $author['msg']);
                return 1;
            }
            $this->info('Author created successfully with ID: ');
            return 1;
        } catch (\Exception $e) {
            $this->error('Error creating author: ' . $e->getMessage());
            return 1;
        }

    }
}
