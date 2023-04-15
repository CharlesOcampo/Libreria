{{foreach products}}
  <div>
    <h3>{{namep}}</h3>
    <p>{{price}}</p>
    <p>{{quantity}}</p>
    {{if enCarretilla}}
      <a href="/carts/{{id}}/remove">Remove from cart</a
    {{endif enCarretilla}}
    {{ifnot enCarretilla}}
      <a href="/carts/{{id}}/add">Add to cart</a>
    {{endifnot enCarretilla}}
  </div>
{{endfor products}}
