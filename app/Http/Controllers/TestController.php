<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;
use Dingo\Api\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TestController extends Controller
{
    public function index(Request $request)
    {
        // $user = User::find(1);
        // return $this->response->array($user->toArray());
        // return $this->response->array(['name' => '阿卡丽', 'age' => 12]);

        // return $this->response->noContent();
        // return $this->response->created();
        // return $this->response->error('提交错误！', 404);
        // return $this->response->errorNotFound('找不到数据');
        // return $this->response->errorUnauthorized('无权限');
        // return $this->response->errorBadRequest('用户id不能为空');

        // throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException('请求错误！');
        // $rules = [
        //     'username' => ['required', 'alpha'],
        //     'password' => ['required', 'min:7']
        // ];

        // $payload = app('request')->only('username', 'password');

        // $validator = app('validator')->make($payload, $rules);

        // throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());

        // $validated = $request->validate([
        //     'title' => 'required|unique:posts|max:255',
        //     'body' => 'required',
        // ]);


        // $user = User::find(1);
        // return $this->response->item($user, new UserTransformer($user));

        // $user = User::all();
        // return $this->response->collection($user, new UserTransformer($user));

        $user = User::paginate(1);
        return $this->response
        ->paginator($user, new UserTransformer($user))
        ->withHeader('X-Foo', 'Bar')
        // ->addMeta('foo', 'bar')
        ->setMeta(['foo' => 'bar'])
        ->setStatusCode(202);
    }

    public function name()
    {
        // $url = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('test.name');
       $url = app(UrlGenerator::class)->version('v1')->route('test.name');
       dd($url);
    }

    public function users()
    {
        $user = User::all();
        return $this->response->collection($user, new UserTransformer($user));
    }

    public function login(Request $request)
    {
        return ['password' => bcrypt(123456)];
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            // throw new BadRequestHttpException('Unauthorized');
            return $this->response->errorUnauthorized();
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
