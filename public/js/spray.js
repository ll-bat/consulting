class Spray {
    constructor(){
        this.current = [0,0]
        this.routes = []
    }
    
    addRoute(route){
        this.routes.push(route)
    }

    runAnimation(frameFunc) {
        function frame(time){
              if (frameFunc() === true) return;
           requestAnimationFrame(frame);
        }
        requestAnimationFrame(frame);
    }  

    async start(){
         for (let i=0; i<this.routes.length;){
             let status = await this.run(this.routes[i])
             if (status == true) {
                 i++
             }
         }
         
         console.log('finished')
    }

    run(route){
        let [radius,  // radius of circular path
             steps,   // number of steps in which spray stops moving
             tx,      // +1 or -1 e.g. direction on x-axis (+1 - spray moves from left to right and vice versa)
             ty,      // +1 or -1 e.g. direction on y-axis
             scx,     // e.g. scaled X. distance on x-axis spray covers will be multiflied on scx, and this will cause elliptic movement
             scy,     // e.g. scaled Y. same way, distance on y-axis will be increased by scy times and this will change moving trajectory
             k = 0,       // e.g. Angle on clockwise 
            ] = route  

        let currentStep = 1 
        let degree = 90 * (1 / steps) 
        let currentDegree = degree
        let dist = [0,0]
        let self = this

        return new Promise(resolve => {
           self.runAnimation(() => {
                if (currentStep == 2*steps){
                    self.current[0] += dist[0]
                    self.current[1] += dist[1]
                    resolve(true)
                    return true 
                }

                let y  = radius * sin(currentDegree / 57)
                let x  = radius * (1 - cos(currentDegree / 57))

                x = tx * x * scx 
                y = ty * y * scy 

                dist[0] = x
                dist[1] = y
                
                st($1(self.element), 
                    `tr:rotate(180deg) translateX(${x + self.current[0]}px) translateY(${y + self.current[1]}px)`)

                currentStep++
                currentDegree += degree
                return false
           })
        })
    }

    create(params){
        let [imagePath, uniqueId, parent] = params
        this.element = uniqueId 

        let c = `<div class='position-absolute'>
                       <img src='${imagePath}' class='spray' id='${uniqueId}' />
                  </div>`

        $1(parent).innerHTML = c + $1(parent).innerHTML
    }
}
